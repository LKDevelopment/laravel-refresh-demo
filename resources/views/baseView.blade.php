@include('demo-refresh::infoLine')

@include('demo-refresh::modal')

<script>
    var nextRollback = '{{ \LKDevelopment\LaravelDemoRefresh\DemoRefresh::getNextRollback() }}';
    $('#nextRollback').html(nextRollback);
    $('#littleModal').modal('show');
</script>