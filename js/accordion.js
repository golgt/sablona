
var accordion = document.getElementsByClassName('accordion');
//mám viacero akordeonov, potrebujem nimi prejsť
for(a of accordion){
    a.addEventListener("click",function(){
      //this hovorí doslova tomuto, po ktorom práve klikáš daj class active
      this.classList.toggle('active');
    })
  }

  document.addEventListener("DOMContentLoaded", () => {
    fetch("data.json")
      .then(response => {
        if (!response.ok) {
          throw new Error("Chyba pri načítaní JSON: " + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        const container = document.querySelector(".accordion-container");

        if (!container) {
          console.error("Nebola nájdená trieda .accordion-container!");
          return;
        }

        // Vyčistíme kontajner pred načítaním
        container.innerHTML = "";

        data.data.forEach(item => {
          const accordion = document.createElement("div");
          accordion.classList.add("accordion");

          accordion.innerHTML = `
            <div class="question">${item.question}</div>
            <div class="answer">${item.answer}</div>
          `;

          container.appendChild(accordion);
        });

        // Event listener pre otázky
        document.querySelectorAll(".question").forEach(q => {
          q.addEventListener("click", () => {
            q.nextElementSibling.classList.toggle("visible");
          });
        });
      })
      .catch(error => console.error("Chyba pri spracovaní JSON:", error));
});
