// ScrollReveal JS

ScrollReveal({ distance: "50px" });

ScrollReveal().reveal(".title", {
  delay: 200,
  easing: "ease-in",
  origin: "top",
  distance: "70px",
  duration: 900,
});

ScrollReveal().reveal(".description", {
  delay: 1000,
  easing: "ease-in",
  origin: "top",
  distance: "30px",
  duration: 1000,
});

ScrollReveal().reveal(".btn", {
  delay: 2000,
  easing: "ease-in-out",
  duration: 1000,
});

ScrollReveal().reveal(".card-container", {
  delay: 400,
  easing: "ease-in-out",
  origin: "right",
  distance: "800px",
  duration: 2500,
});

ScrollReveal().reveal(".gradient-line", {
  delay: 200,
  easing: "ease",
  origin: "left",
  distance: "1800px",
  duration: 3600,
});

ScrollReveal().reveal(".featured-title", {
  delay: 400,
  easing: "ease-in",
  origin: "right",
  distance: "200px",
  duration: 1400,
});

ScrollReveal().reveal(".item", {
  delay: 1200,
  interval: 200,
  origin: "bottom",
  easing: "ease-in-out",
  duration: 400,
});

// Lightbox

document.addEventListener("DOMContentLoaded", function () {
  const galleryImages = document.querySelectorAll(".item img");
  const lightbox = document.querySelector(".lightbox");
  const lightboxImage = document.querySelector(".img-container img");
  const lightboxTitle = document.querySelector(".img-container p");
  const prevBtn = document.querySelector(".prev");
  const nextBtn = document.querySelector(".next");
  const body = document.querySelector("body");

  let currentIndex;

  galleryImages.forEach((img, index) => {
    img.addEventListener("click", function () {
      currentIndex = index;
      updateLightbox();
      lightbox.style.display = "flex";
      body.classList.add("prevent-background-scroll");
    });
  });

  lightbox.addEventListener("click", function (e) {
    if (e.target === lightbox) {
      lightbox.style.display = "none";
      body.classList.remove("prevent-background-scroll");
    }
  });

  prevBtn.addEventListener("click", function () {
    currentIndex =
      (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    updateLightbox();
  });

  nextBtn.addEventListener("click", function () {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    updateLightbox();
  });

  function updateLightbox() {
    const currentImage = galleryImages[currentIndex];
    lightboxImage.src = currentImage.src;
    lightboxTitle.textContent = currentImage.alt;
  }
});
const flame = document.querySelector('.flame');
const blowSound = document.getElementById('blow-sound');

// Function to extinguish the flame
function extinguishFlame() {
  flame.style.height = '0';
  blowSound.play();
}

// Function to detect blowing on the microphone
function detectBlow() {
  navigator.mediaDevices.getUserMedia({ audio: true })
    .then(function(stream) {
      const audioContext = new AudioContext();
      const analyser = audioContext.createAnalyser();
      const microphone = audioContext.createMediaStreamSource(stream);
      const javascriptNode = audioContext.createScriptProcessor(2048, 1, 1);

      analyser.smoothingTimeConstant = 0.8;
      analyser.fftSize = 1024;

      microphone.connect(analyser);
      analyser.connect(javascriptNode);
      javascriptNode.connect(audioContext.destination);

      javascriptNode.onaudioprocess = function() {
        const array = new Uint8Array(analyser.frequencyBinCount);
        analyser.getByteFrequencyData(array);
        const average = array.reduce((a, b) => a + b) / array.length;
        if (average > 100) {
          extinguishFlame();
        }
      };
    })
    .catch(function(err) {
      console.log('The following error occurred: ' + err);
    });
}

// Call the function to detect blowing
detectBlow();
