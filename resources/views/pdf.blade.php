<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    @php
        $content = App\Models\PassportServiceApplication::find($id);
        $headerfooter = App\Models\MailHeaderFooter::where('service_id', $content->service_id)->first();
    @endphp
    <div>{!! $headerfooter->header ?? '' !!}</div>
    <div class="mail-body" style="margin-top:20px; margin-bottom:20px;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Passport No</th>
                    <th>Id No</th>
                    <th>Date Of Application</th>
                    <th>Finger Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $content->user->name ?? 'no name' }}</td>
                    <td>{{ $content->user->userinfo->passport_no ?? 'no passport' }}</td>
                    <td>{{ $content->id_no ?? 'no id' }}</td>
                    <td>{{ $content->online_application_date ?? 'no date' }}</td>
                    <td>{{ $content->finger_status_id->name ?? 'no status' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>{!! $headerfooter->footer ?? '' !!}</div>

</body>

</html>
