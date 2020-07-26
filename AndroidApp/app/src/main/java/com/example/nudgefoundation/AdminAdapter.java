package com.example.nudgefoundation;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Comparator;

public class AdminAdapter extends RecyclerView.Adapter<AdminAdapter.MyViewHolder> {
    ArrayList<MeritModel> meritLists;
    Context context;
    String meritType;
    public AdminAdapter(Context c, ArrayList<MeritModel> g, String meritType)
    {
        meritLists=g;
        context=c;
        this.meritType =meritType;
    }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new MyViewHolder(LayoutInflater.from(context).inflate(R.layout.custom_company_card,parent,true));
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        holder.name.setText(meritLists.get(position).toString());
        holder.assesmentMarks.setText(meritLists.get(position).toString());
    }

    @Override
    public int getItemCount() {
        return meritLists.size();
    }
    public class MyViewHolder extends RecyclerView.ViewHolder{
        TextView name;
        TextView assesmentMarks;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.participant_name);
            assesmentMarks = itemView.findViewById(R.id.assesment_marks);
        }
    }
}
