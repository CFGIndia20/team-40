package com.example.nudgefoundation;

public class MeritModel {
    String name;
    String assesment;

    public MeritModel() {
    }

    public MeritModel(String name, String assesment) {
        this.name = name;
        this.assesment = assesment;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAssesment() {
        return assesment;
    }

    public void setAssesment(String assesment) {
        this.assesment = assesment;
    }
}
