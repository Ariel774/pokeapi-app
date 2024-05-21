<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">Buscador Pokémon</h1>
                        <div class="input-group mb-3">
                            <!-- Usamos @input para validar la entrada cada vez que el usuario escribe -->
                            <input v-model="pokemonName" @input="validateInput" @keyup.enter="search" placeholder="Buscar Pokémon..." class="form-control">
                            <button @click="search" class="btn btn-primary">Buscar</button>
                        </div>

                        <div v-if="error" class="alert alert-danger">{{ error }}</div>

                        <div v-if="abilities.length > 0" class="card mt-3">
                            <div class="card-body">
                                <h2 class="card-title">{{ pokemonName }}</h2>
                                <p class="card-text">Habilidades:</p>
                                <ul class="list-group">
                                    <!-- Mostrar las habilidades traducidas -->
                                    <li v-for="ability in abilities" :key="ability" class="list-group-item">
                                        {{ ability }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <h2 class="mt-4">Últimas búsquedas:</h2>
                        <ul class="list-group">
                            <li v-for="search in searches" :key="search" @click="repeatSearch(search.pokemon_name)" class="list-group-item list-group-item-action">
                                {{ search.pokemon_name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        apiUrl: String
    },
    data() {
        return {
            pokemonName: '',
            abilities: [], // Array para almacenar las habilidades traducidas
            error: null,
            searches: [], // Array para almacenar las búsquedas anteriores
        };
    },
    mounted() {
        this.getSearches(); // Obtener las últimas búsquedas al montar el componente
    },
    methods: {
        async search() {
            try {
                const response = await axios.post('/api/search', { pokemonName: this.pokemonName });
                // Actualizar las habilidades con las traducidas
                this.abilities = response.data.abilities;
                this.error = null;
                this.getSearches(); // Actualizar la lista de búsquedas
            } catch (error) {
                this.error = 'Error al buscar Pokémon';
                this.abilities = [];
            }
        },
        async getSearches() {
            const response = await axios.get('/api/searches');
            this.searches = response.data; // Actualizar la lista de búsquedas con los datos del backend
        },
        async repeatSearch(pokemonName) {
            try {
                this.pokemonName = pokemonName; // Asignamos nuevamente el nuevo pokemon a la variable del nombre Pokemon;
                this.search(); // Llamamos nuevamente a la funcion search para que nos haga la busqueda y nos la guarde.
                this.error = null;
            } catch (error) {
                this.error = 'Error al repetir la búsqueda';
                this.abilities = [];
            }
        },
        validateInput(event) {
            // Permitir solo letras y números, y eliminar caracteres no permitidos
            const value = event.target.value;
            const cleanValue = value.replace(/[^a-zA-Z0-9-]/g, ''); // Letras, números y un guíon para el pokemon "ho-oh" xD
            this.pokemonName = cleanValue; // Actualizar el valor de pokemonName con el valor filtrado
        }
    }
};
</script>

<style scoped>
.error {
    color: red;
}

.list-group-item {
    cursor: pointer;
}

.container {
    max-width: 800px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
}
</style>
