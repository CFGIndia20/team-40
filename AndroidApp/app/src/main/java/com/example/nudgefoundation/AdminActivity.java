package com.example.nudgefoundation;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import java.util.ArrayList;

public class AdminActivity extends AppCompatActivity {

    RecyclerView mRecyclerViewGoogle;
    RecyclerView mRecyclerViewJpmc;

    ArrayList<MeritModel> googleLists;
    ArrayList<MeritModel> jpmcLists;

    FirebaseFirestore dbref;
    FirebaseAuth mAuth;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_admin);
        mRecyclerViewGoogle = findViewById(R.id.recycler_college_event);
        mRecyclerViewJpmc = findViewById(R.id.recycler_group_event);

        mAuth = FirebaseAuth.getInstance();
        dbref = FirebaseFirestore.getInstance();

        fetchGoogle();
        fetchJPMC();

    }
    void fetchGoogle()
    {
        mRecyclerViewGoogle.clearOnScrollListeners();
        mRecyclerViewGoogle.clearOnChildAttachStateChangeListeners();
        // list.clear();
        googleLists =new ArrayList<MeritModel>();



        dbref.collection("Google")
                .orderBy("assesment", Query.Direction.DESCENDING)
                .get()
                .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                    @Override
                    public void onComplete(@NonNull Task<QuerySnapshot> task) {
                        MeritModel meritModel;
                        for (QueryDocumentSnapshot documentSnapshot: task.getResult())
                        {
                            meritModel = documentSnapshot.toObject(MeritModel.class);
                            googleLists.add(meritModel);
                            Toast.makeText(AdminActivity.this, googleLists.size(), Toast.LENGTH_SHORT).show();

                        }
                        mRecyclerViewGoogle.clearOnScrollListeners();
                        mRecyclerViewGoogle.clearOnChildAttachStateChangeListeners();
                        //This sets the all data from the firebase onto the adapter
                        AdminAdapter myPinnedAdapter= new AdminAdapter(AdminActivity.this,googleLists,"Google List");
                        //myGroupAdapter.imageGroupIcon.setImageResource(R.drawable.official);
                        RecyclerView.LayoutManager recyce = new GridLayoutManager(mRecyclerViewGoogle.getContext(),1);
                        mRecyclerViewGoogle.setLayoutManager(recyce);
                        mRecyclerViewGoogle.setItemAnimator(new DefaultItemAnimator());
                        mRecyclerViewGoogle.setAdapter(myPinnedAdapter);
                    }
                });
    }
    void fetchJPMC()
    {

    }
}