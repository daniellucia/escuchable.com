<div class="Episodes">
    <p class="Back"><a href="{{ route('show.view', [$show])}}">Volver</a></p>
    <div class="ShowDescription Sticky">
        <h1>{{$episode->title}}</h1>

        <p>{!! $episode->description !!}</p>
        <div class="Metas">
        <p>
        <small>publicado hace {{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->published))->diffForHumans() }}</small>
        </p>
        </div>
    </div>
</div>
