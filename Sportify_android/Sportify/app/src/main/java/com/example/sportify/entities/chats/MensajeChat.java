package com.example.sportify.entities.chats;

public class MensajeChat {

    int id_mensaje;
    String fecha_m;
    String hora_m;
    String contenido_m;
    String nombre_emisor;
    String foto_usuario;

    public int getId_mensaje() {
        return id_mensaje;
    }

    public void setId_mensaje(int id_mensaje) {
        this.id_mensaje = id_mensaje;
    }

    public String getFecha_m() {
        return fecha_m;
    }

    public void setFecha_m(String fecha_m) {
        this.fecha_m = fecha_m;
    }

    public String getHora_m() {
        return hora_m;
    }

    public void setHora_m(String hora_m) {
        this.hora_m = hora_m;
    }

    public String getContenido_m() {
        return contenido_m;
    }

    public void setContenido_m(String contenido_m) {
        this.contenido_m = contenido_m;
    }

    public String getNombre_emisor() {
        return nombre_emisor;
    }

    public void setNombre_emisor(String nombre_emisor) {
        this.nombre_emisor = nombre_emisor;
    }

    public String getFoto_usuario() {
        return foto_usuario;
    }

    public void setFoto_usuario(String foto_usuario) {
        this.foto_usuario = foto_usuario;
    }
}
