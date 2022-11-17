function darkMode() {
    var setTheme = document.querySelector(".main-panel");
    var countryTheme = document.querySelector(".bg-light");
    var cardTheme = document.querySelector(".card");
    var cardHeading = document.querySelector(".card-title");
    var chartTheme = document.querySelector(".card-chart");

    setTheme.classList.toggle("dark-mode");
    countryTheme.classList.toggle("country-bg");
    cardTheme.classList.toggle("card-bg");
    cardHeading.classList.toggle("card-h4");
    chartTheme.classList.toggle("chart-bg");
    
    const darkModeStr = localStorage.getItem('darkMode');

    if(darkModeStr === '1') {
        localStorage.setItem("darkMode", "0");
        return;
    }

    localStorage.setItem("darkMode", "1");



}



function applyDarkModeGlobal() {
    const darkMode = localStorage.getItem('darkMode');
    if(!darkMode) return;

    if(darkMode === '0') {
        var setTheme = document.querySelector(".main-panel");
        var countryTheme = document.querySelector(".bg-light");
        var cardTheme = document.querySelector(".card"); 
        var cardHeading = document.querySelector(".card-title");
        var chartTheme = document.querySelector(".card-chart");

      setTheme.classList.toggle("light-mode");
      countryTheme.classList.toggle("light-mode");
      cardTheme.classList.toggle("light-mode");
      cardHeading.classList.toggle("light-mode");
      chartTheme.classList.toggle("light-mode");
     return
    }



    var setTheme = document.querySelector(".main-panel");
    var countryTheme = document.querySelector(".bg-light"); 
    var cardTheme = document.querySelector(".card");    
    var cardHeading = document.querySelector(".card-title"); 
    var chartTheme = document.querySelector(".card-chart");
    setTheme.classList.toggle("dark-mode");
    countryTheme.classList.toggle("country-bg");
    cardTheme.classList.toggle("card-bg");
    cardHeading.classList.toggle("card-h4");
    chartTheme.classList.toggle("chart-bg");

}
applyDarkModeGlobal()