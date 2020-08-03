package com.example.sportify.network;


import com.example.sportify.entities.AccessToken;
import com.example.sportify.entities.chats.ListaChat;
import com.example.sportify.entities.chats.ListaMensajesChat;
import com.example.sportify.entities.equipo.IntegranteEquipo;
import com.example.sportify.entities.equipo.ListaEquipos;
import com.example.sportify.entities.equipo.ListaIntegranteEquipo;
import com.example.sportify.entities.eventos.ListaEventos;
import com.example.sportify.entities.eventos.RespuestaEvento;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

public interface ApiService {

    @POST("login")
    @FormUrlEncoded
    Call<AccessToken> login(@Field("email") String email, @Field("password") String password);

    @POST("refresh")
    @FormUrlEncoded
    Call<AccessToken> refresh(@Field("refresh_token") String refreshToken);

    @POST("logout")
    Call<AccessToken> logout();

    @GET("eventos")
    Call<ListaEventos> eventos();

    @GET("mis-eventos")
    Call<ListaEventos> mis_eventos();

    @GET("mis-equipos")
    Call<ListaEquipos> mis_equipos();

    @POST("evento")
    @FormUrlEncoded
    Call<RespuestaEvento> evento(@Field("id_evento") int id_evento);

    @POST("desapuntarse-evento")
    @FormUrlEncoded
    Call<String> desapuntarse(@Field("id_evento") int id_evento,@Field("tipo") String tipo);

    @POST("apuntarse-evento")
    @FormUrlEncoded
    Call<String> apuntarse(@Field("id_evento") int id_evento,@Field("tipo_participante") String tipo_participante, @Field("id_equipo") int id_equipo);

    @POST("equipo")
    @FormUrlEncoded
    Call<ListaIntegranteEquipo> equipo(@Field("id_equipo") int id_equipo);

    @POST("desapuntarse-equipo")
    @FormUrlEncoded
    Call<String> desapuntarse_equipo(@Field("id_equipo") int id_equipo);

    @GET("chats")
    Call<ListaChat> chats();

    @POST("chat-concreto")
    @FormUrlEncoded
    Call<ListaMensajesChat> chat_concreto(@Field("id_grupo_conv") int id_grupo_conv);

    @POST("publicar-mensaje")
    @FormUrlEncoded
    Call<String> publicar_mensaje(@Field("id_grupo_conv") int id_grupo_conv,@Field("cuerpo_mensaje") String cuerpo_mensaje);
}
