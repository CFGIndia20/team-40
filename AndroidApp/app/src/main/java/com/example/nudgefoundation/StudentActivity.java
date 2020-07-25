package com.example.nudgefoundation;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import java.util.ArrayList;

public class StudentActivity extends AppCompatActivity {

    RecyclerView mRecyclerViewCompanyList;
    FirebaseAuth mAuth;
    FirebaseFirestore dbref;
    ArrayList<CompanyModel> companyLists;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student);
        mAuth = FirebaseAuth.getInstance();
        dbref = FirebaseFirestore.getInstance();
        mRecyclerViewCompanyList = findViewById(R.id.recycler_company_list);
        displayCompanyLists();

    }

    private void displayCompanyLists() {
        Toast.makeText(this, "Inside display", Toast.LENGTH_SHORT).show();
        mRecyclerViewCompanyList.clearOnScrollListeners();
        mRecyclerViewCompanyList.clearOnChildAttachStateChangeListeners();
        companyLists = new ArrayList<CompanyModel>();
        dbref.collection("Companies")
                .get()
                .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                    @Override
                    public void onComplete(@NonNull Task<QuerySnapshot> task) {
                        companyLists.clear();
                        if (task.isSuccessful())
                        {
                            for (QueryDocumentSnapshot document: task.getResult())
                            {
                                companyLists.add(document.toObject(CompanyModel.class));
                                Toast.makeText(StudentActivity.this, companyLists.indexOf(0), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }
                });
        mRecyclerViewCompanyList.clearOnScrollListeners();
        mRecyclerViewCompanyList.clearOnChildAttachStateChangeListeners();
        Toast.makeText(this, "Reached Recycler", Toast.LENGTH_SHORT).show();
        //This sets the all data from the firebase onto the adapter
        CompaniesAdapter myAdapter= new CompaniesAdapter(companyLists);
        RecyclerView.LayoutManager recyce=new GridLayoutManager(mRecyclerViewCompanyList.getContext(),1);
        mRecyclerViewCompanyList.setLayoutManager(recyce);
        mRecyclerViewCompanyList.setItemAnimator(new DefaultItemAnimator());
        mRecyclerViewCompanyList.setAdapter(myAdapter);
    }
}