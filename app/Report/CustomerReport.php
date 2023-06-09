<?php

namespace  App\Report;

use App\Models\Customer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerReport
{
    public function list($customers)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(__('platform.report.type.customers'));
        $sheet->getStyle('A1:F1')->getBorders()->getOutline()->setBorderStyle(true);
        $sheet->setCellValue('A1', __('platform.customer.form.id'));
        $sheet->setCellValue('B1', __('platform.customer.form.codigo'));
        $sheet->setCellValue('C1', __('platform.customer.form.fantasia'));
        $sheet->setCellValue('D1', __('platform.customer.form.cep'));
        $sheet->setCellValue('D1', __('platform.customer.form.cidade'));
        $sheet->setCellValue('D1', __('platform.customer.form.logradouro'));
        $sheet->setCellValue('D1', __('platform.customer.form.uf'));
        $sheet->setCellValue('E1', __('platform.generic.action.created_at'));
        $sheet->setCellValue('F1', __('platform.generic.action.updated_at'));
        $line = 2;
        foreach ($customers as $item) {
            $sheet->setCellValueByColumnAndRow(1, $line, $item->id);
            $sheet->setCellValueByColumnAndRow(2, $line, $item->codigo);
            $sheet->setCellValueByColumnAndRow(3, $line, $item->fantasia);
            $sheet->setCellValueByColumnAndRow(4, $line, $item->cep);
            $sheet->setCellValueByColumnAndRow(4, $line, $item->cidade);
            $sheet->setCellValueByColumnAndRow(4, $line, $item->logradouro);
            $sheet->setCellValueByColumnAndRow(4, $line, $item->uf);
            $sheet->setCellValueByColumnAndRow(5, $line, $item->created_at);
            $sheet->setCellValueByColumnAndRow(6, $line, $item->updated_at);
            $line++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "report-" . time() . ".xlsx";
        $writer->save(storage_path('app/public/report/customer/' . $filename));
        $notification = [
            'report'     => true,
            'report_name' => trans('platform.report.singular_name') . " - " . trans('platform.report.type.customers'),
            'report_link' => asset('storage/report/customer/' . $filename),
            'title' => trans('validation.generic.Success'),
            'message' => trans('platform.report.message.generated_success'),
            'alert-type' => 'success'
        ];
        return $notification;
    }
}
