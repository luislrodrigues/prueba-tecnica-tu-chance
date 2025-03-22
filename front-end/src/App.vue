<template>
  <nav class="navbar navbar-expand-lg shadow" style="background-color: #B0D1BA;">
    <div class="container">
      <router-link class="navbar-brand fw-bold" to="/alumnos">Alumnos</router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <div class="container mt-4">
    <router-view />
  </div>
</template>
