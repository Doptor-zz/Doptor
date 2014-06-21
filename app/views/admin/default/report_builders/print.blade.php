<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 2mm;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    <style type="text/css">
        .container {
            width: 960px;
            margin: 0 auto;
        }
        thead {
            background: #eee;
        }
        table {
          border-collapse: collapse;
        }
        td, th {
          border: 1px solid #999;
          padding: 0.5rem;
          text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        @if (!$isPdf)
            <input type="button" onClick="window.print();document.title ='{{$title}}'" class="no-print" value="Print this report"/>
        @endif
        <table>
            <caption>{{ $title }}</caption>
            <br>
            <thead>
                <tr>
                    @foreach ($required_fields as $key=>$value)
                        <th>{{ $value }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $entry)
                    <tr>
                        @foreach ($required_fields as $field=>$value)
                            <td>{{ $entry->{$field} }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
