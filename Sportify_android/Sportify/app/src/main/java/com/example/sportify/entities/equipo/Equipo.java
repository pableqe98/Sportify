package com.example.sportify.entities.equipo;

import java.io.Serializable;

public class Equipo implements Serializable {

    int id_equipo;
    String nombre_equipo;
    String logo_equipo;
    String descripcion_equipo;
    int n_miembros;

    public int getId_equipo() {
        return id_equipo;
    }

    public void setId_equipo(int id_equipo) {
        this.id_equipo = id_equipo;
    }

    public String getNombre_equipo() {
        return nombre_equipo;
    }

    public void setNombre_equipo(String nombre_equipo) {
        this.nombre_equipo = nombre_equipo;
    }

    public String getLogo_equipo() {
        return logo_equipo;
    }

    public void setLogo_equipo(String logo_equipo) {
        this.logo_equipo = logo_equipo;
    }

    public String getDescripcion_equipo() {
        return descripcion_equipo;
    }

    public void setDescripcion_equipo(String descripcion_equipo) {
        this.descripcion_equipo = descripcion_equipo;
    }

    public int getN_miembros() {
        return n_miembros;
    }

    public void setN_miembros(int n_miembros) {
        this.n_miembros = n_miembros;
    }
}
