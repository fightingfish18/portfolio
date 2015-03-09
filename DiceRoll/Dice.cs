using System;

namespace DiceRoll
{
	public class Dice
	{
		Random r;
		public Dice ()
		{
			r = new Random ();
		}

		public int[] roll(int sides, int num)
		{
			int[] rolls = new int[num];
			for (int i = 0; i < num; i++) {
				rolls [i] = r.Next (sides) + 1;
			}
			return rolls;
		}
	}
}

