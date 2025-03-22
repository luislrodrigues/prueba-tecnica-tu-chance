import { createRouter, createWebHistory } from "vue-router";
import ListarAlumnos from "./views/ListarAlumnos.vue";
import DetalleAlumno from "./views//DetalleAlumno.vue";
const routes = [
  {
    path: "/",
    redirect: "/alumnos", // Redirige la raíz a /alumnos
  },
  { path: "/alumnos", 
    component: ListarAlumnos 
  },
  { path: "/alumnos/:id", 
    component: DetalleAlumno, 
    name: "detalleAlumno"
   }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
