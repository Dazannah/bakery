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

fetch("/last-week-profit")
  .then(response => {
    if (response.ok) {
      return response.json();
    } else {
      console.log(response.statusText);
    }
  })
  .then(data => {
    console.log(data);
    const lastWeekProfit = document.getElementById("last-week-profit");
    lastWeekProfit.innerText = data;
  })
  .catch(error => console.log(error));

fetch("/three-column")
  .then(response => {
    if (response.ok) {
      return response.json();
    } else {
      console.log(response.statusText);
    }
  })
  .then(data => {
    const glutenFreeTable = document.getElementById("gluten-free").getElementsByTagName("tbody")[0];
    const lactoseFreeTable = document.getElementById("lactose-free").getElementsByTagName("tbody")[0];
    const glutenAndLactoseFree = document.getElementById("gluten-and-lactose-free").getElementsByTagName("tbody")[0];

    glutenFreeTable.innerHTML = generateTbody(data.glutenFree);
    lactoseFreeTable.innerHTML = generateTbody(data.lactoseFree);
    glutenAndLactoseFree.innerHTML = generateTbody(data.glutenAndLactoseFree);
  })
  .catch(error => console.log(error));

function generateTbody(array) {
  let resultHtml = "";
  array.forEach(food => {
    resultHtml += `<tr>`;
    food.forEach(element => {
      resultHtml += `<td>${element}${isNaN(element) ? "" : " Ft"}</td>`;
    });
    resultHtml += `</tr>`;
  });

  return resultHtml;
}
