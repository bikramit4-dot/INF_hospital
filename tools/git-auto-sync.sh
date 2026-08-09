#!/bin/bash
#
# git-auto-sync.sh
# =================
# Watches the hospital-website project folder and automatically commits
# and pushes changes to GitHub after a short "quiet period" with no edits.
#
# Usage:
#   ./tools/git-auto-sync.sh                       # run in foreground
#   QUIET_SECONDS=10 ./tools/git-auto-sync.sh      # override quiet period
#
# The script is normally started in the background (nohup) or by the
# LaunchAgent at ~/Library/LaunchAgents/com.hospital.git-autosync.plist.
# It logs to storage/git-auto-sync.log (which is excluded from git).

PROJECT_DIR="/Applications/XAMPP/xamppfiles/htdocs/hospital-website"
REMOTE="origin"
BRANCH="main"
QUIET_SECONDS="${QUIET_SECONDS:-60}"   # seconds of no edits before syncing
POLL_INTERVAL=5                        # seconds between checks
LOG_FILE="$PROJECT_DIR/storage/git-auto-sync.log"

cd "$PROJECT_DIR" || { echo "Project dir not found: $PROJECT_DIR"; exit 1; }

# Make sure storage exists so we can write the log
mkdir -p "$(dirname "$LOG_FILE")"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

log "Auto-sync started (PID $$) watching $PROJECT_DIR"

LAST_SNAPSHOT=""
LAST_CHANGE_TIME=0

while true; do
    SNAPSHOT=$(git status --porcelain 2>/dev/null)

    if [ -n "$SNAPSHOT" ]; then
        if [ "$SNAPSHOT" != "$LAST_SNAPSHOT" ]; then
            LAST_SNAPSHOT="$SNAPSHOT"
            LAST_CHANGE_TIME=$(date +%s)
            COUNT=$(printf '%s\n' "$SNAPSHOT" | wc -l | tr -d ' ')
            log "Change detected ($COUNT item(s)) - waiting for edits to settle..."
        elif [ $(( $(date +%s) - LAST_CHANGE_TIME )) -ge "$QUIET_SECONDS" ]; then
            log "Edits settled - committing and pushing..."
            git add -A
            if ! git diff --cached --quiet; then
                git commit -m "Auto-sync: $(date '+%Y-%m-%d %H:%M:%S')" >> "$LOG_FILE" 2>&1
            fi
            if git push "$REMOTE" "$BRANCH" >> "$LOG_FILE" 2>&1; then
                log "Pushed to GitHub ($REMOTE/$BRANCH)."
            else
                log "Push failed - will retry on the next check."
            fi
            LAST_SNAPSHOT=""
            LAST_CHANGE_TIME=0
        fi
    else
        # No working-tree changes - retry any pending push (e.g. failed earlier)
        AHEAD=$(git rev-list --count "origin/$BRANCH..$BRANCH" 2>/dev/null || echo 0)
        if [ "${AHEAD:-0}" -gt 0 ]; then
            log "Retrying push ($AHEAD commit(s) ahead)..."
            if git push "$REMOTE" "$BRANCH" >> "$LOG_FILE" 2>&1; then
                log "Pushed to GitHub ($REMOTE/$BRANCH)."
            fi
        fi
        LAST_SNAPSHOT=""
        LAST_CHANGE_TIME=0
    fi

    sleep "$POLL_INTERVAL"
done
