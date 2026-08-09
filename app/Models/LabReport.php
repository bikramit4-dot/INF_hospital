<?php
namespace App\Models;

use App\Core\Model;

class LabReport extends Model
{
    protected static string $table = 'lab_reports';
    protected static string $primaryKey = 'id';

    /**
     * Find a report by its report_id string.
     */
    public static function findByReportId(string $reportId): ?array
    {
        return self::firstWhere('report_id = :rid', [':rid' => $reportId]);
    }

    /**
     * Get results for a specific report.
     */
    public static function getResults(int $labReportId): array
    {
        $db = new static();
        return $db->getDb()->fetchAll(
            'SELECT * FROM lab_report_results WHERE lab_report_id = :id ORDER BY sort_order',
            [':id' => $labReportId]
        );
    }

    /**
     * Add a single result row to a report.
     */
    public static function addResult(int $labReportId, array $data): void
    {
        $db = new static();
        $db->getDb()->execute(
            'INSERT INTO lab_report_results (lab_report_id, parameter_name, result_value, reference_range, is_abnormal, sort_order)
             VALUES (:rid, :name, :value, :range, :abn, :sort)',
            [
                ':rid' => $labReportId,
                ':name' => $data['parameter_name'],
                ':value' => $data['result_value'],
                ':range' => $data['reference_range'],
                ':abn' => !empty($data['is_abnormal']) ? 1 : 0,
                ':sort' => (int) ($data['sort_order'] ?? 0),
            ]
        );
    }

    /**
     * Delete a single result row, scoped to a report (returns false if not found).
     */
    public static function deleteResult(int $labReportId, int $resultId): bool
    {
        $db = new static();
        return $db->getDb()->execute(
            'DELETE FROM lab_report_results WHERE id = :id AND lab_report_id = :rid',
            [':id' => $resultId, ':rid' => $labReportId]
        ) > 0;
    }

    /**
     * Look up a report by report_id AND phone number.
     */
    public static function lookup(string $reportId, string $phone): ?array
    {
        $report = self::findByReportId($reportId);
        if ($report && $report['patient_phone'] === $phone) {
            $report['results'] = self::getResults((int)$report['id']);
            return $report;
        }
        return null;
    }
}