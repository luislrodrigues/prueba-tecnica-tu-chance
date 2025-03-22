<template>
    <ModalAlumno :alumnoData="alumnoSeleccionado" :grados="grados" @alumnoGuardado="listarAlumnos" />
  <div class="card shadow p-4">
    <div class="row text-center mb-3">
      <h2 class="mb-0">Lista de Alumnos</h2>
    </div>
    <div class="row g-2 mb-3">
      <div class="col-4">
        <input type="text" class="form-control" v-model="buscar" placeholder="Buscar alumno..." />
      </div>
      <div class="col-4 d-flex gap-2">
        <select class="form-select" v-model="grado" @change="listarAlumnos(1)">
          <option value="">Todos los grados</option>
          <option v-for="grado in grados" :key="grado.id" :value="grado.id">{{ grado.nombre }}</option>
        </select>
      </div>
      <div class="col-4 d-flex justify-content-center">
        <button class="btn btn-secondary mx-2" @click="listarAlumnos(1)">
          <i class="fas fa-search"></i> Buscar
        </button>
        <button class="btn btn-primary mx-2" @click="nuevoAlumno()" data-bs-toggle="modal" data-bs-target="#modalAlumno">
        <i class="fas fa-plus"></i> Agregar
      </button>
      </div>
    </div>

    <table class="table table-striped mt-3" v-if="alumnos.length">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Grado</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="alumno in alumnos" :key="alumno.id">
          <td>{{ alumno.nombre }}</td>
          <td>{{ alumno.grado?.nombre }}</td>
          <td class="text-center">
            <button class="btn btn-light btn-sm me-2"  @click="verDetalle(alumno.id)">
              <i class="fas fa-eye" title="Detalle"></i>
            </button>
            <button class="btn btn-warning btn-sm me-2" @click="editarAlumno(alumno)" data-bs-toggle="modal" data-bs-target="#modalAlumno">
              <i class="fas fa-edit" title="Editar"></i>
            </button>
            <button class="btn btn-danger btn-sm" title="Eliminar" @click="eliminarAlumno(alumno.id)">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    
    <p v-else class="text-center text-muted">No hay alumnos disponibles.</p>

    <!-- Paginación -->
    <nav v-if="pagination.total > 1" class="mt-3">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: !pagination.prev_page_url }">
          <button class="page-link" @click="listarAlumnos(pagination.current_page - 1)">Anterior</button>
        </li>
        <li class="page-item" v-for="page in pagination.last_page" :key="page"
          :class="{ active: page === pagination.current_page }">
          <button class="page-link" @click="listarAlumnos(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: !pagination.next_page_url }">
          <button class="page-link" @click="listarAlumnos(pagination.current_page + 1)">Siguiente</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { store } from "@/stores/store";
import { mapActions } from "pinia";
import { mapState } from "pinia";
import ModalAlumno from "@/components/alumnos/ModalAlumno.vue";

export default {
  components: { ModalAlumno },
  data() {
    return {
      alumnos: [],
      alumnoSeleccionado:{},
      buscar: "",
      grado: "",
      pagination: {
        total: 0,
        per_page: 10,
        current_page: 1,
        last_page: 1,
        next_page_url: null,
        prev_page_url: null,
      },
    };
  },
  computed: {
    ...mapState(store, ["grados"]),
  },
  methods: {
    ...mapActions(store, ["listarGrados","quitarModalCargaGeneral","mostrarModalCargaGeneral"]),
    async listarAlumnos(page = 1) {
      this.mostrarModalCargaGeneral();
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/alumnos", {
          params: { page, nombre: this.buscar, grado: this.grado }
        });
        this.alumnos = response.data.data;
        this.pagination = {
          total: response.data.total,
          per_page: response.data.per_page,
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          next_page_url: response.data.next_page_url,
          prev_page_url: response.data.prev_page_url,
        };
         this.quitarModalCargaGeneral();
      } catch (error) {
         this.quitarModalCargaGeneral();
        Swal.fire("Error", "No se pudieron cargar los alumnos.", "error");
      }
    },

    eliminarAlumno(id) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.mostrarModalCargaGeneral();
          try {
             const response = await axios.delete(`http://127.0.0.1:8000/api/alumnos/${id}`);
             this.quitarModalCargaGeneral();
             if(response.data.success){
               Swal.fire("Eliminado", response.data.message, "success").then(()=>{
                this.listarAlumnos();
               });
             }else{
                   Swal.fire("Atención", response.data.message, "error")
             }
          } catch (error) {
            this.quitarModalCargaGeneral();
            Swal.fire("Error", "No se pudo eliminar el alumno.", "error");
            console.error(error);
          }
        }
      });
    },
    nuevoAlumno() {
      this.alumnoSeleccionado = {};
    },
    editarAlumno(alumno) {
      this.alumnoSeleccionado = { ...alumno };
    },
    verDetalle(id) {
      this.$router.push({ name: "detalleAlumno", params: { id } });
    },

  },
  mounted() {
    this.listarAlumnos();
    this.listarGrados();
  },
};
</script>
