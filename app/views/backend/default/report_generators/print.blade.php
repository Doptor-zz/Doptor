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
        .center {
            margin-left: auto;
            margin-right: auto;
            width: 70%;
        }
        table {
            margin: 0 auto 40px auto;
            border-collapse: collapse;
        }
        thead {
            background: #eee;
        }
        table caption {
            margin: 0 0 20px 0;
        }
        h2 {
            margin: 0 0 5px 0;
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
        <br><br>

        <table>
            <caption>
            <h1>{{ @$website_settings['company_name'] }}</h1>
            <h2>{{ $title }}</h2>
            @if ($input['start_date'] != '')
                From: {{ $input['start_date'] }}
            @endif
            @if ($input['end_date'] != '')
                To: {{ $input['end_date'] }}
            @endif
            </caption>
        </table>
        @foreach ($modules as $module)
            <table>
                <caption>
                    {{ $module['form_name'] }}
                </caption>
                @if ($module['required_fields'])
                    <thead>
                        <tr>
                            @foreach ($module['required_fields'] as $key=>$value)
                                <th>{{ $value }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($module['entries'] as $entry)
                            <tr>
                                @foreach ($module['required_fields'] as $field=>$value)
                                    <td>{{ $entry->{$field} }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        @endforeach
        <br><br>
        Printed by: {{ $current_user->username }} on {{ date('Y-m-d h:m:i') }}
    </div>
</body>
</html>
