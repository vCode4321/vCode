const cards = [
  {
    img: { src: "assets/images/portfolio/Ecommerce-1.png", alt: "" },
    category: "Ecommerce",
  },
  {
    img: { src: "assets/images/portfolio/Ecommerce-2.png", alt: "" },
    category: "Ecommerce",
  },
  {
    img: { src: "assets/images/portfolio/Ecommerce-3.png", alt: "" },
    category: "Ecommerce",
  },
  {
    img: { src: "assets/images/portfolio/Ecommerce-4.png", alt: "" },
    category: "Ecommerce",
  },
  {
    img: { src: "assets/images/portfolio/Construction-1.png", alt: "" },
    category: "Construction",
  },
  {
    img: { src: "assets/images/portfolio/Construction-2.png", alt: "" },
    category: "Construction",
  },
  {
    img: { src: "assets/images/portfolio/Construction-3.png", alt: "" },
    category: "Construction",
  },
  {
    img: { src: "assets/images/portfolio/Construction-4.png", alt: "" },
    category: "Construction",
  },
  {
    img: { src: "assets/images/portfolio/Auto-tech-1.png", alt: "" },
    category: "Auto-tech",
  },
  {
    img: { src: "assets/images/portfolio/Auto-tech-2.png", alt: "" },
    category: "Auto-tech",
  },
  {
    img: { src: "assets/images/portfolio/Auto-tech-3.png", alt: "" },
    category: "Auto-tech",
  },
  {
    img: { src: "assets/images/portfolio/Fintech-1.png", alt: "" },
    category: "Fintech",
  },
  {
    img: { src: "assets/images/portfolio/Fintech-2.png", alt: "" },
    category: "Fintech",
  },
  {
    img: { src: "assets/images/portfolio/Healthcare-1.png", alt: "" },
    category: "Healthcare",
  },
  {
    img: { src: "assets/images/portfolio/Healthcare-2.png", alt: "" },
    category: "Healthcare",
  },
  {
    img: { src: "assets/images/portfolio/Healthcare-3.png", alt: "" },
    category: "Healthcare",
  },
  {
    img: { src: "assets/images/portfolio/Healthcare-4.png", alt: "" },
    category: "Healthcare",
  },
  {
    img: { src: "assets/images/portfolio/Mobile-1.png", alt: "" },
    category: "Mobile",
  },
  {
    img: { src: "assets/images/portfolio/Mobile-2.png", alt: "" },
    category: "Mobile",
  },
];

document.addEventListener("DOMContentLoaded", () => {
  const gallery = document.querySelector(".main__gallery");

  cards.forEach((card) => {
    const cardElement = document.createElement("article");
    cardElement.classList.add("card");
    cardElement.dataset.category = card.category;

    cardElement.innerHTML = `
        <div class="card__img-box">
          <img class="card__img" src="${card.img.src}" alt="${card.img.alt}">
        </div>
      `;

    gallery.appendChild(cardElement);
  });
});

const filterImgs = (btn) => {
  const cards = document.querySelectorAll(".card");
  const btnCategory = btn.dataset.category;

  document.querySelectorAll(".primary-btn").forEach((button) => {
    button.classList.remove("primary-btn_active");
  });

  btn.classList.add("primary-btn_active");

  // Zoom-out effect for all visible images
  cards.forEach((card) => {
    if (card.style.display === "block" || card.style.display === "") {
      card.querySelector(".card__img").classList.add("zoom-out");
    }
  });

  setTimeout(() => {
    cards.forEach((card) => {
      card.querySelector(".card__img").classList.remove("zoom-out");
      if (!btnCategory || card.dataset.category === btnCategory) {
        card.style.display = "block";
        card.querySelector(".card__img").classList.add("zoom-in");
      } else {
        card.style.display = "none";
      }
    });
  }, 300);
};
