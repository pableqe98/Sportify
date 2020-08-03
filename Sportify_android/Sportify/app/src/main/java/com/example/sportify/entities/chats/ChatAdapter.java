package com.example.sportify.entities.chats;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.sportify.R;
import com.example.sportify.entities.eventos.Evento;
import com.example.sportify.entities.eventos.EventoAdapter;
import com.squareup.picasso.Picasso;

import java.util.List;

public class ChatAdapter extends BaseAdapter {

    protected Context context;
    protected List<Chat> items;

    public ChatAdapter(final Context context,final List<Chat> items) {
        this.context = context;
        this.items = items;
    }

    public void clear(){
        items.clear();
    }

    public void addAll(List<Chat> chats){
        items.clear();
        for(int i=0 ; i < chats.size() ; i++)
            items.add(chats.get(i));
    }

    @Override
    public int getCount() {
        return items.size();
    }

    @Override
    public Object getItem(int i) {
        return items.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }
    public List<Chat> getItems() {
        return items;
    }

    @Override
    public View getView(int i, View convertView, ViewGroup parent) {
        ViewHolderChats viewHolder;

        if(convertView == null){
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(R.layout.chat_item,parent,false);

            viewHolder = new ViewHolderChats();
            viewHolder.id_chat = (TextView)convertView.findViewById(R.id.t_id_chat);
            viewHolder.titulo_chat = (TextView) convertView.findViewById(R.id.t_titulo_chat);

            convertView.setTag(viewHolder);
        }
        else{
            viewHolder = (ViewHolderChats) convertView.getTag();
        }

        Chat obj = items.get(i);

        if(items != null){
            viewHolder.id_chat.setText(Integer.toString(obj.getId_grupo_conv()));
            viewHolder.titulo_chat.setText(obj.getNombre_grupo());

        }

        return convertView;

    }

    static class ViewHolderChats{
        TextView id_chat;
        TextView titulo_chat;

    }
}
