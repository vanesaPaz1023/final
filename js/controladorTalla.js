
function agregarTalla() {
    const nombre = document.getElementById("nombre").value;
    const descripcion = document.getElementById("descripcion").value;
    const unidad = document.getElementById("unidad").value;
    
    const url = "../../proceso/gestionTalla.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "agregar");
    formData.append("nombre",nombre);
    formData.append("descripcion",descripcion);
    formData.append("unidad",unidad); 
  
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            document.getElementById("nombre").value='';
            document.getElementById("descripcion").value='';
            document.getElementById("unidad").value='';
            alert("dia accesible agregado con éxito!");
        } else {
            alert("Error al agregar el dia accesible.");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al agregar el dia accesible.");
    });
}
function editarTalla() {
    const nombre = document.getElementById("nombre").value;
    const descripcion = document.getElementById("descripcion").value;
    const unidad = document.getElementById("unidad").value;
    const id = document.getElementById("idTalla").value;
    
    const url = "../../proceso/gestionTalla.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "editar");
    formData.append("nombre",nombre);
    formData.append("descripcion",descripcion);
    formData.append("unidad",unidad);
    formData.append("id",id);
  
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            document.getElementById("editarTallaForm").reset();
            alert("Dias Accesibles se actualizo con éxito!");
            window.location.href = '../../form/Talla/gestionTalla.php';
        } else {
            alert("Error al agregar el dia accesible.");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al agregar el dia accesible.");
    });
}