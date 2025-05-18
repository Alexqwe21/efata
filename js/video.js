   
        const video = document.getElementById('video');
        const source = document.getElementById('videoSource');

        const videos = [
            'video/cultura_efata.mp4',
            'video/treino.mp4'
        ];

        let current = 0;

        video.addEventListener('ended', function () {
            // Avança para o próximo vídeo da lista, ou volta ao início
            current = (current + 1) % videos.length;
            source.src = videos[current];
            video.load();
            video.play();
        });
    



