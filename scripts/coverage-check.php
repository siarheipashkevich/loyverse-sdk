<?php

declare(strict_types=1);

$report = $argv[1] ?? 'build/coverage.xml';
$threshold = (float) ($argv[2] ?? 80);

if (! is_file($report)) {
    fwrite(STDERR, sprintf("Coverage report not found: %s\n", $report));
    exit(1);
}

$xml = simplexml_load_file($report);

if ($xml === false) {
    fwrite(STDERR, sprintf("Unable to parse coverage report: %s\n", $report));
    exit(1);
}

$metrics = $xml->project->metrics;
$statements = (int) $metrics['statements'];
$covered = (int) $metrics['coveredstatements'];

if ($statements === 0) {
    fwrite(STDERR, "Coverage report contains no statements.\n");
    exit(1);
}

$percent = ($covered / $statements) * 100;

printf("Line coverage: %.2f%% (%d/%d), required: %.2f%%\n", $percent, $covered, $statements, $threshold);

if ($percent < $threshold) {
    exit(1);
}
