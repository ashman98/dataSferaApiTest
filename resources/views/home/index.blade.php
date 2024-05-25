<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrations</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<div id="integration_grid">
    <div>
        <h1>Продажи</h1>
        <div style="display: flex">
        <form id="sales_form" action="{{ route('integration.sales') }}" method="POST">
            @csrf
            <label for="from_date">From Date:</label>
            <input type="date" id="from_date" name="from_date" value="{{$sales['fromDate']}}" required>

            <label for="to_date">To Date:</label>
            <input type="date" id="to_date" name="to_date" value="{{$sales['toDate']}}" required>


        </form><button class="submit_b" id="sales"  @if ($sales['count'] > 0) disabled @endif>Submit</button>
        </div>
        <p>Количество продажи в базе: {{$sales['count']}}</p>
    </div>
    <div>
        <h1>Заказы</h1>
        <div style="display: flex">
            <form id="orders_form" action="{{ route('integration.orders') }}" method="POST">
                @csrf
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" value="{{$orders['fromDate']}}" required>

                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" value="{{$orders['toDate']}}" required>

            </form><button class="submit_b" id="orders"  @if ($orders['count'] > 0) disabled @endif>Submit</button>
        </div>
        <p>Количество заказов в базе: {{$orders['count']}}</p>
    </div>
    <div>
        <h1>Склады</h1>
        <div style="display: flex">
            <form  id="stocks_form"  action="{{ route('integration.stocks') }}" method="POST">
                @csrf
                <label for="from_date">Date from:</label>
                <input type="date" id="from_date" name="from_date" value="{{$stocks['fromDate']}}" readonly required>
            </form><button class="submit_b" id="stocks" @if ($stocks['count'] > 0) disabled @endif>Submit</button>
        </div>
        <p>Количество складов в базе: {{$stocks['count']}}</p>
    </div>
    <div>
        <h1>Доходы</h1>

        <div style="display: flex">
            <form id="incomes_form" action="{{ route('integration.incomes') }}" method="POST">
                @csrf
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" value="{{$incomes['fromDate']}}" required>

                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" value="{{$incomes['toDate']}}" required>


            </form><button class="submit_b" id="incomes" @if ($incomes['count'] > 0) disabled @endif>Submit</button>
        </div>
        <p>Количество доходыов в базе: {{$incomes['count']}}</p>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    document.querySelectorAll('.submit_b').forEach((bt) => {
        bt.addEventListener('click', function() {
            const formId = this.id + '_form';
            const form = document.getElementById(formId);

            Swal.fire({
                title: 'Внимание',
                text: 'В базе данных могут создаваться дубликаты!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    console.log('User clicked No or closed the dialog');
                }
            });
        });
    });
</script>
</body>
</html>
