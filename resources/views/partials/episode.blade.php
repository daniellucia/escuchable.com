<div class="Episodes">

    <div class="ShowDescription Sticky">
        <div class="HeaderTitle">
            <h1>{{$episode->title}}</h1>
            <p class="Back"><a class="Button" href="{{ route('show.view', [$show])}}">Volver</a></p>
        </div>
        <p>{!! $episode->description !!}</p>
        <div class="Metas">
        <p>
        <small>publicado hace {{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->published))->diffForHumans() }}</small>
        </p>
        </div>
    </div>
</div>
