<?php
require_once 'parsecsv.lib.php';

$csv = new parseCSV();

$csv->auto('awards.csv');
$awards = $csv->data;
$csv->auto('contracts.csv');
$contracts = $csv->data;

foreach($contracts as $contract) {
    foreach($awards as $award) {
        if($contract['contractname'] == $award['contractName']) {
            $data[] = array_merge($contract, $award);
        }
    }
}

foreach($data as $d) {
    unset($d['contractName']);
    $new_data[] = $d;
}

$final_fields = array(
    'contractName',
    'status',
    'bidPurchaseDeadline',
    'bidSubmissionDeadline',
    'bidOpeningDate',
    'tenderid',
    'publicationDate',
    'publishedIn',
    'contractDate',
    'completionDate',
    'awardee',
    'awardeeLocation',
    'Amount'
);
$final_csv = $csv->output(null, $new_data, $final_fields);
file_put_contents('final.csv', $final_csv);

$csv->conditions = 'status = Current';
$csv->auto('final.csv');
$total = count($csv->data);

echo "Total Amount of current contracts: ".$total;
