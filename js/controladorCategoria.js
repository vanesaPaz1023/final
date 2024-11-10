
function agregarCategoria() {
  const nombre = document.getElementById("catNombre").value;

  const url = "../../proceso/gestionCategoria.php";
  const formData = new FormData();
  formData.append("action", "agregar");
  formData.append("nombre", nombre);

  fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors",
  })
  .then((response) => response.json())
  .then((data) => {
      if (data.ok) {
          document.getElementById("catNombre").value = ''; // Limpiar el campo
          alert("Categoría agregada con éxito!"); // Mensaje de éxito
      } else {
          alert("Error al agregar la categoría."); // Mensaje de error
      }
  })
  .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un problema al agregar la categoría."); // Mensaje de error en la consola
  });
}
function editarCategoria() {
    const nombre = document.getElementById("catNombre").value;
    const id = document.getElementById("idCategoria").value;
    const estado = document.getElementById("estado").value;
    
    const url = "../../proceso/gestionCategoria.php";
    const formData = new FormData();
    formData.append("action", "editar");
    formData.append("nombre", nombre);
    formData.append("id", id);
    formData.append("estado", estado);
  
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            document.getElementById("categoriaForm").reset();
            alert("Categoría se agrego con éxito!"); // Mensaje de éxito
            window.location.href = '../../form/Categoria/gestionCategoria.php';
        } else {
            alert("Error al agregar la categoría."); // Mensaje de error
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al agregar la categoría."); // Mensaje de error en la consola
    });
  }




