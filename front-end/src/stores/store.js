import { defineStore } from "pinia";
import axios from "axios";
import Swal from "sweetalert2";

export const store = defineStore("store", {
  state: () => ({
    grados: [],
  }),

  actions: {
    async listarGrados() {
        try {
          const response = await axios.get("http://127.0.0.1:8000/api/grados");
          this.grados = response.data;
        } catch (error) {
          Swal.fire("Error", "No se pudieron cargar los grados.", "error");
        }
      },
      mostrarModalCargaGeneral(){
        Swal.fire({
          title: "Cargando...",
          text: "Esto puede tardar un poco, espere por favor...",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });
      },
      quitarModalCargaGeneral(){
        Swal.close();
      },
  },
});
