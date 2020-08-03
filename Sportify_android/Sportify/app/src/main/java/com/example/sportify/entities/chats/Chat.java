package com.example.sportify.entities.chats;

import java.io.Serializable;

public class Chat implements Serializable {

    int id_grupo_conv;
    String nombre_grupo;

    public int getId_grupo_conv() {
        return id_grupo_conv;
    }

    public void setId_grupo_conv(int id_grupo_conv) {
        this.id_grupo_conv = id_grupo_conv;
    }

    public String getNombre_grupo() {
        return nombre_grupo;
    }

    public void setNombre_grupo(String nombre_grupo) {
        this.nombre_grupo = nombre_grupo;
    }
}
