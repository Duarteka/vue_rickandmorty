<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Rick and Morty</title>
</head>
<body>
    <div class="contenedor">
        <header class="cabecera">
            <img src="img/apiRickandMorty.svg" alt="">
                <div class="contenedor-buscar">
                    <h3>Busca un personaje por su nombre:</h3> 
                    <input class="buscar" v-model="buscador" type="text" placeholder="ej. rick"></input>
                </div>
         </header>
    <div class="contenedor-personaje">
        <personaje v-for="item, indice in nombresFiltrados" :key="indice" :personaje="item"></personaje>
    </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
   
<script>
       Vue.component("personaje",{
           props : ["personaje"],
           template : `<div class="caracter"><div class="image"><img :src="url(personaje)"></div><p>NAME: {{personaje.name}}</p><p>GENERO: {{personaje.gender}}</p><p>ESTATUS: {{personaje.status}}</p><p>Location: {{personaje.location.name}}</p></div>`,
            methods : {
               url(personaje){
                   return personaje.image
            }
        },
    });

    var app = new Vue({
        el : ".contenedor",
        data : {
            avatar : [],
            buscador : ''
        },
        computed : {
            nombresFiltrados(){
                var nombres = this.avatar.filter((item)=>{
                    return item.name.toLowerCase().includes(this.buscador.toLowerCase())
                }) 
                //nombres.unshift(this.avatar[0])
                    
                //console.log(nombres)
                return nombres
            }
        },
        created(){

            funcionRecursiva = (results, i, totalPersonajes)=>{
                fetch("https://rickandmortyapi.com/api/character/?page="+(i))
                    .then(response => response.json())
                    .then(json => {
                        var characters_per_fetch = 20 //en cada pagina hay 20 personajes
                        this.avatar = results.concat(json.results); 
                        //obtengo el numero total de personajes de la api               
                        if (totalPersonajes == null) {
                            totalPersonajes = json.info.count;
                        }
                        //calculo si me quedan personajes en la api
                        if (i < (totalPersonajes/characters_per_fetch)){
                            funcionRecursiva(this.avatar, i + 1, totalPersonajes)
                        }
                    })
                }
            funcionRecursiva(this.avatar, 1, null)        
        }
    });

 //principal problemas a resolver: no podia hacer fetchs dinamicos en funcion del numero de personajes obtenidos de un fetch inicial, 
 //Solucion: usar una func. recursiva que se llame a si misma si quedan personajes que buscar en la api
    </script>
</body>
</html>