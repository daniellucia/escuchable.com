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


        <div id="audio" class="Player"></div>
        <div class="Controls">
            <button id="Play" class="Button Disabled">Play</button>
            <button id="Pause" class="Button Disabled">Pause</button>
            <span id="LoadingAudio"></span>
        </div>

    </div>
</div>

<script src="https://unpkg.com/wavesurfer.js"></script>
<script>
    var wavesurfer

    (function() {
        function UpdateLoadingFlag(Percentage) {
            if (document.getElementById("LoadingAudio")) {
                document.getElementById("LoadingAudio").innerText = "Precargando audio " + Percentage + "%";
                if (Percentage >= 100) {
                    document.getElementById("LoadingAudio").innerHTML = "Espere un momento...";
                } else {
                    document.getElementById("LoadingAudio").style.display = "block";
                }
            }
        }

        wavesurfer = WaveSurfer.create({
            container: '#audio',
            waveColor: '#91b9e2',
            progressColor: '#295c90',
            barWidth: 2,
            barHeight: 1,
            barGap: null
        });

        wavesurfer.on('loading', function(X, evt) {
            UpdateLoadingFlag(X);
        });

        wavesurfer.on('ready', function() {
            document.getElementById("Play").classList.remove("Disabled");
            document.getElementById("LoadingAudio").style.display = "none";
        });

        wavesurfer.load("{{ $episode->mp3 }}");

        document.getElementById("Play").addEventListener("click", function() {
            wavesurfer.play();
            document.getElementById("Pause").classList.remove("Disabled");
            document.getElementById("Play").classList.add("Disabled");
        })
        document.getElementById("Pause").addEventListener("click", function() {
            wavesurfer.pause();
            document.getElementById("Play").classList.remove("Disabled");
            document.getElementById("Pause").classList.add("Disabled");
        })
    })();
</script>
