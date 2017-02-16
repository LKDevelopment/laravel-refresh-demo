@include('refresh-demo::infoLine')

@include('refresh-demo::modal')

<script>
    var _laravel_refresh_demo_nextRollbackTimestamp = '{{ RefreshDemo::getNextRollback()->timestamp }}';
    $('#_laravel_refresh_demo_nextRollback').html('{{ RefreshDemo::getNextRollback()->format(trans('refresh-demo::refresh-demo.infoLine.dateTimeFormat')) }}');
    var _laravel_refresh_demo_timeout = window.setInterval(function () {
        if (_laravel_refresh_demo_nextRollbackTimestamp == Math.floor(Date.now() / 1000)) {
            window.clearTimeout(_laravel_refresh_demo_timeout);
            $('#laravel_demo_refresh_modal').modal('show');
            window.setTimeout(function () {
                window.location.reload();
            }, ({{ config('refresh-demo.views.holdUserOnPopupForSeconds') }} * 1000));
        }
    }, 1000);
</script>