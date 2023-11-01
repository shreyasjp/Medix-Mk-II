const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)");
const captchaCode = document.getElementById("captcha-code");

function setTheme() {
  const isDarkMode = prefersDarkMode.matches;
  if (captchaCode) {
    captchaCode.src = isDarkMode ? "PHP Modules/DarkCaptcha.php" : "PHP Modules/Captcha.php";
  }
  document.body.classList.toggle("light", !isDarkMode);
  document.body.classList.toggle("dark", isDarkMode);
}

function handleLoad() {
  const loader = document.getElementById("page-loader");
  const content = document.getElementById("container");
  const navBar = document.querySelector("nav");

  if (loader && content) {
    loader.remove();
    content.classList.remove("hide");
    if (navBar){
      navBar.classList.remove("hide");
    }
  }
}

// Initial setup
setTheme();

// Update theme when the preference changes
prefersDarkMode.addEventListener("change", setTheme);

// Handle the load event for the entire page
window.addEventListener("load", handleLoad);