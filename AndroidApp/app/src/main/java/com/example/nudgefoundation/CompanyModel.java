package com.example.nudgefoundation;

public class CompanyModel {
    String company_name;
    String company_logo;
    String description;
    String estimated_CTC;
    String company_ID;

    public CompanyModel() {
    }

    public CompanyModel(String company_name, String company_logo, String description, String estimated_CTC, String company_ID) {
        this.company_name = company_name;
        this.company_logo = company_logo;
        this.description = description;
        this.estimated_CTC = estimated_CTC;
        this.company_ID = company_ID;
    }

    public String getCompany_name() {
        return company_name;
    }

    public void setCompany_name(String company_name) {
        this.company_name = company_name;
    }

    public String getCompany_logo() {
        return company_logo;
    }

    public void setCompany_logo(String company_logo) {
        this.company_logo = company_logo;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getEstimated_CTC() {
        return estimated_CTC;
    }

    public void setEstimated_CTC(String estimated_CTC) {
        this.estimated_CTC = estimated_CTC;
    }

    public String getCompany_ID() {
        return company_ID;
    }

    public void setCompany_ID(String company_ID) {
        this.company_ID = company_ID;
    }
}
