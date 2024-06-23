import java.util.ArrayList;

import ardoise.*;

public class GF extends Forme {
    private ArrayList<Forme> formes;
    private static final String typeforme = "GF";

    public GF(String nom, ArrayList<Forme> f) {
        super(nom);

        try {
            checkForValidFormes(f);
            this.formes = f;
        } catch (IllegalArgumentException e) {
            this.formes = new ArrayList<Forme>();
            System.out.println("Error: Formes Invalides  " + e.getMessage());
        }
    }

    private void checkForValidFormes(ArrayList<Forme> formes) throws IllegalArgumentException {
        for (Forme forme : formes) {
            if (forme == null) {
                throw new IllegalArgumentException("Forme object is null.");
            }
        }
    }

    @Override
    public void deplacer(int arg0, int arg1) {
        for (Forme forme : formes) {
            forme.deplacer(arg0, arg1);
        }
    }

    @Override
    public ArrayList<Segment> dessiner() {
        ArrayList<Segment> totale = new ArrayList<Segment>();
        for (Forme forme : formes) {
            totale.addAll(forme.dessiner());
        }
        return totale;
    }

    @Override
    public String typeForme() {
        return typeforme;
    }
}
