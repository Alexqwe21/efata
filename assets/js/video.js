const video = document.getElementById("video");
const source = document.getElementById("videoSource");
const thumbnail = document.getElementById("thumbnail");
const player = new Plyr(video);

const videos = ["assets/video/cultura_efata.mp4", "assets/video/treino.mp4"];

let current = 0;

// Exibe vídeo e inicia
function showVideo() {
  thumbnail.style.display = "none";
  video.style.display = "block";
  player.play();
}

// Quando o vídeo termina, troca para o próximo e toca
video.addEventListener("ended", function () {
  current = (current + 1) % videos.length;
  source.src = videos[current];
  video.load();
  player.play();
});
