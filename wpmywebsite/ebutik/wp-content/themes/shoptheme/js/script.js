/* all scripts used on the web site */
/* Dark/light mode script with local storage function*/
const page = document.querySelector(".page");
const toggle = page.querySelector(".toggle-input");
const toggleIcon = page.querySelector(".toggle-icon");
// set theme and localStorage on page load
setCheckedState();
function setCheckedState() {
  // checks if localStorage has a "checked" value set at all
  if (!(localStorage.checked === undefined)) {
    // if it does, it sets the state of the toggle accordingly
    toggle.checked = isTrue(localStorage.getItem("checked"));
    // after setting the toggle state, the theme is adjusted according to the checked state
    toggleTheme();}}
function toggleTheme() {
  // Toggle theme based on state of checkbox
  if (toggle.checked) {
    page.classList.replace("light", "dark");
  } else {
    page.classList.replace("dark", "light");}
  // replace icons on page
  toggleIconTheme();
  // set the value of the "checked" key in localStorage
  localStorage.setItem("checked", toggle.checked);}
function toggleIconTheme() {
  // Replace icons not able to be targeted by css variables
  if (page.classList.contains("light")) {
    toggleIcon.src = "/wpmywebsite/ebutik/wp-content/themes/shoptheme/img/moon.png";
    } else {
    toggleIcon.src = "/wpmywebsite/ebutik/wp-content/themes/shoptheme/img/sun.png";}}
function isTrue(value) {
  // convert string to boolean
  return value === "true";}
// Toggle theme any time the state of the checkbox changes
toggle.addEventListener("change", toggleTheme);
//script for copyright year
document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()));



//script for table of contents
/* highlights the currently viewed article segement in the table of content */
/*window.addEventListener('DOMContentLoaded', () => {
	const observer = new IntersectionObserver(entries => {
		entries.forEach(entry => {
			const id = entry.target.getAttribute('id');
			if (entry.intersectionRatio > 0) {
				document.querySelector(`nav li a[href="#${id}"]`).parentElement.classList.add('active');
			} else {
				document.querySelector(`nav li a[href="#${id}"]`).parentElement.classList.remove('active');
			}		});	});
	// Track all sections that have an `id` applied
	document.querySelectorAll('section[id]').forEach((section) => {
		observer.observe(section);
	});
});*/



