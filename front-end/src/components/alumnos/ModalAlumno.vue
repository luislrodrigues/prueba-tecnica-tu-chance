<template>
  <div class="modal fade" id="modalAlumno" tabindex="-1" aria-labelledby="modalAlumnoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAlumnoLabel">{{ isEditing ? "Editar Alumno" : "Agregar Alumno" }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="guardarAlumno">
            <div class="mb-3">
              <label class="form-label">Nombre</label>
              <input type="text" v-model="alumno.nombre" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Fecha de Nacimiento</label>
              <input type="date" v-model="alumno.fecha_nacimiento" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Nombre padre</label>
              <input type="text" v-model="alumno.nombre_padre" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Nombre madre</label>
              <input type="text" v-model="alumno.nombre_madre" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Grado</label>
              <select v-model="alumno.grado_id" class="form-control">
                <option v-for="grado in grados" :key="grado.id" :value="grado.id">
                  {{ grado.nombre }}
                </option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Seccion</label>
              <input type="text" v-model="alumno.seccion" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Fecha de ingreso</label>
              <input type="date" v-model="alumno.fecha_ingreso" class="form-control" />
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { Modal } from "bootstrap";
export default {
  props: {
    alumnoData: Object,
    grados: Array,
  },
  data() {
    return {
      alumno: {
        nombre: "",
        nombre_padre: "",
        nombre_madre: "",
        seccion:  "",
        fecha_nacimiento: "",
        fecha_ingreso: "",
        grado_id: null,
      },
      isEditing: false,
    };
  },
  watch: {
    alumnoData(newVal) {
      if (newVal?.id) {
        this.isEditing = true;
        this.alumno = { ...newVal };
      } else {
        this.isEditing = false;
        this.alumno = {
          nombre: "",
          fecha_nacimiento: "",
          grado_id: null,
        };
      }
    },
  },
  methods: {
    async guardarAlumno() {
      if (!this.validarAlumno()) {
          return;
      }
      try {
        if (this.isEditing) {
          await axios.put(`http://127.0.0.1:8000/api/alumnos/${this.alumno.id}`, this.alumno);
          Swal.fire("Éxito", "Alumno actualizado correctamente", "success").then(()=>{
            this.cerrarModal();
            this.$emit("alumnoGuardado");
          });
        } else {
          await axios.post("http://127.0.0.1:8000/api/alumnos", this.alumno);
          Swal.fire("Éxito", "Alumno agregado correctamente", "success").then(()=>{
            this.cerrarModal();
            this.$emit("alumnoGuardado");
          });
        }
      } catch (error) {
        this.cerrarModal();
        let errors = error.response?.data.errors;
        Swal.fire({
              title: "Error",
              html: `<ul>${errors.map(error => `<li>${error}</li>`).join("")}</ul>`,
              icon: "error"
        });
      }
    },
    cerrarModal(){
      const modalElement = document.getElementById("modalAlumno");
      if (modalElement) {
        const modalInstance =
          Modal.getInstance(modalElement) || new Modal(modalElement);
        modalInstance.hide();
        setTimeout(() => {
          const backdrop = document.querySelector(".modal-backdrop");
          if (backdrop) {
            backdrop.remove();
          }
        }, 500);
      }
    },
    validarAlumno() {
        const camposObligatorios = [
          { campo: this.alumno.nombre, mensaje: "El nombre es obligatorio." },
          { campo: this.alumno.nombre_padre, mensaje: "El nombre del padre es obligatorio." },
          { campo: this.alumno.nombre_madre, mensaje: "El nombre de la madre es obligatorio." },
          { campo: this.alumno.fecha_nacimiento, mensaje: "La fecha de nacimiento es obligatoria." },
          { campo: this.alumno.fecha_ingreso, mensaje: "La fecha de ingreso es obligatoria." },
          { campo: this.alumno.grado_id, mensaje: "Debe seleccionar un grado." },
          { campo: this.alumno.seccion, mensaje: "La sección es obligatoria." }
        ];
        const errores = camposObligatorios
          .filter(item => !item.campo || item.campo.toString().trim() === "")
          .map(item => item.mensaje);

        if (errores.length > 0) {
          Swal.fire({
            title: "Errores en el formulario",
            html: `<ul>${errores.map(error => `<li>${error}</li>`).join("")}</ul>`,
            icon: "error"
          });
          return false;
        }
        return true;
      }
  },
};
</script>
