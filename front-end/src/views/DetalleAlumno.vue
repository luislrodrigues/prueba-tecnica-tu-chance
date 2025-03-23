<template>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
      <h2 class="text-center text-primary mb-4">Detalle del Alumno</h2>
      <div >
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Nombre:</strong> {{ alumno.nombre }}</li>
          <li class="list-group-item"><strong>Fecha de nacimiento:</strong> {{ alumno.fecha_nacimiento }}</li>
          <li class="list-group-item"><strong>Nombre del padre:</strong> {{ alumno.nombre_padre }}</li>
          <li class="list-group-item"><strong>Nombre de la madre:</strong> {{ alumno.nombre_madre }}</li>
          <li class="list-group-item"><strong>Grado:</strong> {{ alumno.grado?.nombre }}</li>
          <li class="list-group-item"><strong>Sección:</strong> {{ alumno.seccion }}</li>
        </ul>
      </div>
      <button @click="$router.push('/alumnos')" class="btn btn-primary w-100 mt-3">
        <i class="fas fa-arrow-left me-2"></i> Volver
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { store } from "@/stores/store";
import { mapActions } from "pinia";
export default {
  data() {
    return {
      alumno: {},
    };
  },
  async created() {
    this.mostrarModalCargaGeneral();
    const id = this.$route.params.id;
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/alumnos/${id}`);
      this.alumno = response.data?.data || {};
      this.quitarModalCargaGeneral();
    } catch (error) {
      Swal.fire("Error", "No se pudo consultar el alumno.", "error").then(() => {
        this.$router.push("/alumnos");
      });
    }
  },
  methods: {
    ...mapActions(store, ["quitarModalCargaGeneral","mostrarModalCargaGeneral"]),
  },
};
</script>
