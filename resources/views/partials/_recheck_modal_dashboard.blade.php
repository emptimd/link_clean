<div class="modal fade" id="confirm-recheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Recheck this campaign</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <div class="m72" style="display: none;">
                <p>Are you sure you want to reanalyze "<span class="campaign_url"></span>"?</p>
                <p>This action requires <span class="backlinks"></span> backlinks credit.</p>
                </div>
                <div class="l72" style="display: none;">
                <p>Sorry. But there's no sense to crawl your links so often.</p>
                <p>The function will be available in <span class="hours"></span> hours.</p>
                </div>

            </div>
            <div class="m72" style="display: none;">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
{{--                @if(\Auth::id() == 127)--}}
                <a class="btn btn-info btn-ok btn-restart ga-restart">Restart with GA</a>
                <a class="btn btn-info btn-ok btn-restart">Restart without GA</a>
                {{--@else--}}
                    {{--<a class="btn btn-info btn-ok btn-restart">OK</a>--}}
                {{--@endif--}}

            </div>
            </div>
        </div>
    </div>
</div>