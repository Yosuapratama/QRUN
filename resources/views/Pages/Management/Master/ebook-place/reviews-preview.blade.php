<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Export Review</title>
    <style>
        * { box-sizing:border-box; }
        body { font-family:-apple-system,Segoe UI,Roboto,Arial,sans-serif; margin:0; padding:14px; background:#fff; color:#2f3640; }
        .meta { font-size:12px; color:#858796; margin-bottom:10px; }
        .meta b { color:#2f3640; }
        table { border-collapse:collapse; width:100%; font-size:12.5px; }
        thead th { background:#1F4E78; color:#fff; text-align:left; padding:8px 10px; position:sticky; top:0;
            white-space:nowrap; font-weight:600; }
        tbody td { padding:7px 10px; border-bottom:1px solid #eef1f7; vertical-align:top;
            overflow-wrap:anywhere; word-break:break-word; }
        tbody tr:nth-child(even) { background:#f8fafc; }
        .empty { text-align:center; color:#9aa1b1; padding:30px; font-style:italic; }
        .cell-empty { color:#c5cad6; }
    </style>
</head>
<body>
    <div class="meta">
        Preview <b>{{ count($rows) }}</b> baris pertama
        @if ($totalReviews > count($rows)) (dari total <b>{{ $totalReviews }}</b> review — semua akan diekspor) @endif.
        Kolom: <b>{{ count($headings) }}</b>.
    </div>

    @if (empty($headings))
        <div class="empty">Tidak ada kolom dipilih.</div>
    @elseif (empty($rows))
        <div class="empty">Belum ada review.</div>
    @else
        <table>
            <thead>
                <tr>
                    @foreach ($headings as $h)
                        <th>{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{!! $cell === '' ? '<span class="cell-empty">—</span>' : e($cell) !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
