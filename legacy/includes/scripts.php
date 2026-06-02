<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if(localStorage.getItem("tema") === "escuro"){
        document.body.classList.add("bg-dark","text-light");
        document.querySelectorAll(".card").forEach(c=>{
            c.classList.add("bg-secondary","text-light");
        });
    }
});

function alternarTema(){
    const escuro = localStorage.getItem("tema") === "escuro";
    localStorage.setItem("tema", escuro ? "claro":"escuro");
    location.reload();
}
</script>
