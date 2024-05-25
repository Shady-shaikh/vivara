// AOS
AOS.init({
    duration: 700,
    easing: "ease",
    once: true,
    disable: "mobile",
});

// function filterAnimation() {
//   const rightToLeft = document.querySelector(".right-to-left");
//   const filterBtn = document.getElementById("filter-btn");

//   filterBtn.addEventListener("click", function () {
//     rightToLeft.classList.toggle("hiding");
//   });

//   setTimeout(() => {
//     ;
//   }, "1000");
// }

const slideFilter = () => {
    const btn = document.querySelector("#filter-btn");
    const options = document.querySelector(".filter-options");

    if (btn) {
        btn.addEventListener("click", () => {
            options.classList.toggle("show");
        });
    }
};
slideFilter();

const clickedButton = () => {
    document.addEventListener("click", function () {});
};
