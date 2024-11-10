function hexToRGB(hex) {
    hex = hex.replace('#', '');
  
    // Convierte el valor hexadecimal a los componentes R, G y B
    const r = parseInt(hex.slice(0, 2), 16);
    const g = parseInt(hex.slice(2, 4), 16);
    const b = parseInt(hex.slice(4, 6), 16);
  
    return { r, g, b };
}
  
  
function agregarColor() {
    const color = document.getElementById("color").value;
    const rgb = hexToRGB(color); 
  
    const R=rgb['r'];
    const G=rgb['g'];
    const B=rgb['b'];
    
    const url = "../../proceso/gestionColor.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "agregar");
    formData.append("R",R);
    formData.append("G",G);
    formData.append("B",B);
  
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            document.getElementById("color").value = ''; 
            alert("Disponibilidad agregada con éxito!");
        } else {
            alert("Error al agregar la disponibilidad.");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al agregar la disponibilidad.");
    });
}

function editarColor() {
    const R = document.getElementById("R").value;
    const G = document.getElementById("G").value;
    const B = document.getElementById("B").value;
    const id = document.getElementById("idColor").value;
    
    const url = "../../proceso/gestionColor.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "editar");
    formData.append("id",id);
    formData.append("R",R);
    formData.append("G",G);
    formData.append("B",B);
  
    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            document.getElementById("editarColorForm").reset();
            alert("Disponibilidad se actualizo con exito!");
            window.location.href = '../../form/Color/gestionColor.php';
        } else {
            alert("Error al actualizar la disponibilidad.");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al actualizar la disponibilidad.");
    });
}