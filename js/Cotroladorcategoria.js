// document.addEventListener("DOMContentLoaded", function () {
//     let btnCategoria = document.getElementById("btnCategoria");
//     btnCategoria.addEventListener("click", function (event) {
//         let nombre =  document.getElementById("catNombre").value;
//         let estado = document.getElementById('catEstado').checked;
//         alert("nombre");

      
//     }); 
// });
function agregarCategoria (){
    let nombre =  document.getElementById("catNombre").value;
    let estado = document.getElementById('catEstado').checked;
  
    let url = "../proceso/Categoria.php";
    let formData = new FormData();
    formData.append("action", "agregar");
    formData.append("nombre", nombre);
    formData.append("estado", estado);
  
    fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.ok) {
            document.getElementById("catNombre").value='';
            document.getElementById('catEstado').checked = false;
        }
      });
  }