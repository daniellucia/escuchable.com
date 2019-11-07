<div class="Episodes">

    @yield('breadcrumbs')

    <div class="ShowDescription Sticky">
        <div class="HeaderTitle">
            <h1>{{$episode->title}}</h1>
            <p class="Back"><a class="Button" href="{{ route('show.view', [$show])}}">Volver</a></p>
        </div>
        <div class="Description">
        <p>{!! $episode->description !!}</p>
            <div class="Metas">
                <p>
                <small>publicado hace {{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->published))->diffForHumans() }}</small>
                </p>
            </div>
        </div>

        <div id="audio" class="Player">
            <audio controls>
                <source src="{{ $episode->mp3 }}" type="audio/mpeg">
                Tu navegador no soporte audio
            </audio>
        </div>

    </div>
</div>
