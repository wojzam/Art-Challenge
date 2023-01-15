const dailyTab = document.querySelector('#tab-daily');
const weeklyTab = document.querySelector('#tab-weekly');

function openDailyTab() {
    dailyTab.classList.add('selected');
    weeklyTab.classList.remove('selected');
}

function openWeeklyTab() {
    weeklyTab.classList.add('selected');
    dailyTab.classList.remove('selected');
}

openDailyTab();

dailyTab.addEventListener('click', openDailyTab);
weeklyTab.addEventListener('click', openWeeklyTab);