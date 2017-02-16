<div id="laravel_demo_refresh_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ trans('refresh-demo::refresh-demo.refreshModal.header') }}</h2>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    @if(config('refresh-demo.views.fontAwesome4'))
                        <i class="fa fa-spin fa-spinner fa-2x"></i>
                    @endif
                    {{ trans('refresh-demo::refresh-demo.refreshModal.body') }}
                </div>
            </div>
        </div>
    </div>
</div>
