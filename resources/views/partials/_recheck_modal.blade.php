<div class="modal fade" id="confirm-recheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Recheck this campaign</h4>
            </div>
            <div class="modal-body" style="text-align: center">
                @if($hours > 72)
                <p>Are you sure you want to reanalyze "{{ $campaign->url }}"?</p>
                <p>This action requires {{ $backlinks_total }} backlinks credit.</p>
                @else
                <p>Sorry. But there's no sense to crawl your links so often.</p>
                <p>The function will be available in {{ 72-$hours }} hours.</p>
                @endif

            </div>
            @if($hours > 72)
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{{ url('campaign/'.$campaign->id.'/restart') }}" class="btn btn-info btn-ok btn-restart ga-restart" data-campaign_id="{{ $campaign->id }}">Restart with GA</a>
                <a href="{{ url('campaign/'.$campaign->id.'/restart') }}" class="btn btn-info btn-ok btn-restart">Restart without GA</a>
            </div>
            @endif
        </div>
    </div>
</div>