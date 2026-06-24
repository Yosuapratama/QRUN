<?php

namespace App\Http\Controllers\Concerns;

use App\Models\EbookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Shared logic for previewing / exporting ebook review answers. Used by both
 * the location detail (EbookPlaceController) and the ebook detail
 * (EbookController) — the only difference is where the questions come from.
 */
trait ReviewExportable
{
    /**
     * Available export columns: fixed base columns plus one per review question.
     *
     * @param iterable $questions Collection of EbookReviewQuestion.
     */
    protected function reviewColumns($questions): array
    {
        $cols = [
            ['key' => 'date',   'label' => 'Tanggal'],
            ['key' => 'rating', 'label' => 'Rating'],
            ['key' => 'ebook',  'label' => 'Ebook'],
        ];

        foreach ($questions as $q) {
            $cols[] = [
                'key'      => 'q' . $q->id,
                'label'    => $q->question,
                'qid'      => $q->id,
                'question' => $q->question,
            ];
        }

        return $cols;
    }

    /**
     * Resolve the ordered, visible columns from request `cols` (csv of keys).
     * Unknown keys are dropped; an empty request falls back to all columns.
     */
    protected function resolveSelectedColumns(array $allColumns, Request $request): array
    {
        $available = collect($allColumns)->keyBy('key');
        $requested = array_filter(array_map('trim', explode(',', (string) $request->input('cols'))));

        if (empty($requested)) {
            return $available->values()->all();
        }

        $selected = [];
        foreach ($requested as $key) {
            if ($available->has($key)) {
                $selected[] = $available->get($key);
            }
        }

        return $selected ?: $available->values()->all();
    }

    /** Resolve one cell value for a review + column definition. */
    protected function reviewCellValue(EbookReview $review, array $col): string
    {
        switch ($col['key']) {
            case 'date':
                return $review->created_at ? Carbon::parse($review->created_at)->format('Y-m-d H:i') : '';
            case 'rating':
                return $review->rating ? $review->rating . '/5' : '';
            case 'ebook':
                return (string) ($review->ebook_slug ?: '');
        }

        foreach (($review->answers ?? []) as $a) {
            $matchId = isset($col['qid']) && ($a['id'] ?? null) == $col['qid'];
            $matchText = isset($col['question']) && ($a['question'] ?? null) === $col['question'];
            if ($matchId || $matchText) {
                $ans = $a['answer'] ?? '';
                return is_array($ans) ? implode(', ', $ans) : (string) $ans;
            }
        }

        return '';
    }

    /** Build [headings, rows] for the selected columns over a set of reviews. */
    protected function buildReviewExport($reviews, array $cols): array
    {
        $headings = array_map(fn ($c) => $c['label'], $cols);

        $rows = [];
        foreach ($reviews as $review) {
            $row = [];
            foreach ($cols as $col) {
                $row[] = $this->reviewCellValue($review, $col);
            }
            $rows[] = $row;
        }

        return [$headings, $rows];
    }
}
