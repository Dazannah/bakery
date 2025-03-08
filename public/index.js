fetch("/last-week-income")
  .then(response => {
    if (response.ok) {
      return response.json();
    } else {
      console.log(response.statusText);
    }
  })
  .then(data => {
    const lastWeekIncome = document.getElementById("last-week-income");
    lastWeekIncome.innerText = data;
  })
  .catch(error => console.log(error));
