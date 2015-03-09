// The AssassinNode class is used to store the information for one
// player in the game of assassin.  Initiallly the "killer" field
// is set to null, but when the person is killed, this should be
// set to the name of the killer.

public class AssassinNode {
    public String name;        // this person's name
    public String killer;      // name of who killed this person
    public AssassinNode next;  // next node in the list

    public AssassinNode(String name) {
        this(name,null);
    }

    public AssassinNode(String name, AssassinNode next) {
        this.name = name;
        this.killer = null;
        this.next = next;
    }
}
