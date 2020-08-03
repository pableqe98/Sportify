package com.example.sportify.entities.eventos;


import java.io.Serializable;
import java.util.Date;

public class Evento implements Serializable {

    int id_evento;
    String titulo_e;
    String descripcion_e;
    String fecha_ini;
    String fecha_fin;
    int min_participantes;
    int max_participantes;
    int n_participantes;
    String foto;
    String tipo;
    Double latitud;
    Double longitud;
    String estado;
    int id_grupo_conv;
    int id_tematica;
    int id_usuario_creador;
    String tipo_participantes;
    String tematica;

    public String getTematica() {
        return tematica;
    }

    public void setTematica(String tematica) {
        this.tematica = tematica;
    }

    public int getId_evento() {
        return id_evento;
    }

    public void setId_evento(int id_evento) {
        this.id_evento = id_evento;
    }

    public String getTitulo_e() {
        return titulo_e;
    }

    public void setTitulo_e(String titulo_e) {
        this.titulo_e = titulo_e;
    }

    public String getDescripcion_e() {
        return descripcion_e;
    }

    public void setDescripcion_e(String descripcion_e) {
        this.descripcion_e = descripcion_e;
    }

    public String getFecha_ini() {
        return fecha_ini;
    }

    public void setFecha_ini(String fecha_ini) {
        this.fecha_ini = fecha_ini;
    }

    public String getFecha_fin() {
        return fecha_fin;
    }

    public void setFecha_fin(String fecha_fin) {
        this.fecha_fin = fecha_fin;
    }

    public int getMin_participantes() {
        return min_participantes;
    }

    public void setMin_participantes(int min_participantes) {
        this.min_participantes = min_participantes;
    }

    public int getMax_participantes() {
        return max_participantes;
    }

    public void setMax_participantes(int max_participantes) {
        this.max_participantes = max_participantes;
    }

    public int getN_participantes() {
        return n_participantes;
    }

    public void setN_participantes(int n_participantes) {
        this.n_participantes = n_participantes;
    }

    public String getFoto() {
        return foto;
    }

    public void setFoto(String foto) {
        this.foto = foto;
    }

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public Double getLatitud() {
        return latitud;
    }

    public void setLatitud(Double latitud) {
        this.latitud = latitud;
    }

    public Double getLongitud() {
        return longitud;
    }

    public void setLongitud(Double longitud) {
        this.longitud = longitud;
    }

    public String getEstado() {
        return estado;
    }

    public void setEstado(String estado) {
        this.estado = estado;
    }

    public int getId_grupo_conv() {
        return id_grupo_conv;
    }

    public void setId_grupo_conv(int id_grupo_conv) {
        this.id_grupo_conv = id_grupo_conv;
    }

    public int getId_tematica() {
        return id_tematica;
    }

    public void setId_tematica(int id_tematica) {
        this.id_tematica = id_tematica;
    }

    public int getId_usuario_creador() {
        return id_usuario_creador;
    }

    public void setId_usuario_creador(int id_usuario_creador) {
        this.id_usuario_creador = id_usuario_creador;
    }

    public String getTipo_participantes() {
        return tipo_participantes;
    }

    public void setTipo_participantes(String tipo_participantes) {
        this.tipo_participantes = tipo_participantes;
    }
}
