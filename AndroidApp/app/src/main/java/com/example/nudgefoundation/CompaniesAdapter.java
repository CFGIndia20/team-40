package com.example.nudgefoundation;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;
import com.google.firebase.firestore.SetOptions;

import java.util.ArrayList;
import java.util.List;

public class CompaniesAdapter extends RecyclerView.Adapter<CompaniesAdapter.MyViewHolder> {
    private List<CompanyModel> companyList;
    LinearLayout linearLayout;
    FirebaseFirestore dbref;
    FirebaseAuth mAuth;
    MemberStudent memberStudent = new MemberStudent();
    int flag              = 1;
    public class MyViewHolder extends RecyclerView.ViewHolder {
        //public TextView title, desc;
        //public String title, String eventDate, String eventTime, String venue, String reminderSet, String desciption
        public TextView companyTitle;
        public TextView             companyDescrpition;
        public TextView             companyCTC;
        public Button applyButton;

        public MyViewHolder(View view) {
            super(view);
            dbref = FirebaseFirestore.getInstance();
            mAuth = FirebaseAuth.getInstance();
            companyTitle              = view.findViewById(R.id.t_title);
            companyDescrpition               = view.findViewById(R.id.t_description);
            companyCTC               = view.findViewById(R.id.t_ctc);
            applyButton                   = view.findViewById(R.id.btn_apply);
            linearLayout            = view.findViewById(R.id.id);

        }
    }
    public CompaniesAdapter(List<CompanyModel> companyList) {
        this.companyList = companyList;
    }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.custom_company_card, parent, false);
        Toast.makeText(itemView.getContext(), "Reached on create", Toast.LENGTH_SHORT).show();
        return new MyViewHolder(itemView);

    }

    @Override
    public void onBindViewHolder(@NonNull final MyViewHolder holder, int position) {
        CompanyModel companyModel =companyList.get(position);
        holder.companyTitle.setText(companyModel.getCompany_name());
        holder.companyDescrpition.setText(companyModel.getDescription());
        holder.companyCTC.setText(companyModel.getEstimated_CTC());
        /*holder.applyButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                final ArrayList<MemberStudent> studentLists = new ArrayList<MemberStudent>();
                dbref.collection("Students")
                        .get()
                        .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                            @Override
                            public void onComplete(@NonNull Task<QuerySnapshot> task) {
                                if (task.isSuccessful())
                                {
                                    holder.applyButton.setText("Applied");
                                    holder.applyButton.setBackgroundResource(R.color.green);
                                }
                                for (QueryDocumentSnapshot document: task.getResult())
                                {
                                    memberStudent = document.toObject(MemberStudent.class);
                                    if (memberStudent.getStudent_id().equals(mAuth.getUid()))
                                    {
                                        dbref.collection("Companies")
                                                .document(companyModel.getCompany_ID())
                                                .collection("StudentsApplied")
                                                .document(mAuth.getUid())
                                                .set(memberStudent, SetOptions.merge());

                                    }
                                }
                            }
                        });

            }
        });*/
    }

    @Override
    public int getItemCount() {
        return companyList.size();
    }
}
