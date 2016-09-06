<?php

namespace VulgarDetectorBundle\Normalizer;

class StopWordsNormalizer implements Normalizer
{
    const WORDS_EN = [
        "a", "about", "above", "above", "across", "after", "afterwards", "again",
        "against", "all", "almost", "alone", "along", "already", "also", "although",
        "always", "am", "among", "amongst", "amoungst", "amount", "an", "and",
        "another", "any", "anyhow", "anyone", "anything", "anyway", "anywhere",
        "are", "around", "as", "at", "back", "be", "became", "because", "become",
        "becomes", "becoming", "been", "before", "beforehand", "behind", "being",
        "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom",
        "but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt",
        "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each",
        "eg", "eight", "either", "eleven", "else", "elsewhere", "empty", "enough", "etc",
        "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few",
        "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former",
        "formerly", "forty", "found", "four", "from", "front", "full", "further", "get",
        "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here",
        "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself",
        "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest",
        "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least",
        "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine",
        "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself",
        "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no",
        "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of",
        "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others",
        "otherwise", "our", "ours", "ourselves", "out", "over", "own", "part", "per",
        "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed",
        "seeming", "seems", "serious", "several", "she", "should", "show", "side",
        "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something",
        "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten",
        "than", "that", "the", "their", "them", "themselves", "then", "thence", "there",
        "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they",
        "thickv", "thin", "third", "this", "those", "though", "three", "through",
        "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards",
        "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very",
        "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever",
        "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever",
        "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose",
        "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours",
        "yourself", "yourselves", "the"
    ];

    const WORDS_PL = [
        "a", "aby", "ach", "acz", "aczkolwiek", "aj", "albo", "ale", "ależ", "aż", "bardziej",
        "bardzo", "bez", "bo", "bowiem", "by", "byli", "bynajmniej", "być", "był", "była",
        "było", "były", "będzie", "będą", "cali", "cała", "cały", "ci", "cię", "ciebie",
        "co", "cokolwiek", "coś", "czasami", "czasem", "czemu", "czy", "czyli", "daleko",
        "dla", "dlaczego", "dlatego", "do", "dobrze", "dokąd", "dość", "dużo", "dwa", "dwaj",
        "dwie", "dwoje", "dziś", "dzisiaj", "gdy", "gdyby", "gdyż", "gdzie", "gdziekolwiek",
        "gdzieś", "go", "i", "ich", "ile", "im", "inna", "inne", "inny", "innych", "iż",
        "ja", "ją", "jak", "jakaś", "jakby", "jaki", "jakichś", "jakie", "jakiś", "jakiż",
        "jakkolwiek", "jako", "jakoś", "je", "jeden", "jedna", "jedno", "jednak", "jednakże",
        "jego", "jej", "jemu", "jest", "jestem", "jeszcze", "jeśli", "jeżeli", "już", "ją",
        "każdy", "kiedy", "kilka", "kimś", "kto", "ktokolwiek", "ktoś", "która", "które",
        "którego", "której", "który", "których", "którym", "którzy", "ku", "lat", "lecz",
        "lub", "ma", "mają", "mam", "mi", "mimo", "między", "mną", "mnie", "mogą", "moi",
        "moim", "moja", "moje", "może", "możliwe", "można", "mój", "mu", "musi", "my", "na",
        "nad", "nam", "nami", "nas", "nasi", "nasz", "nasza", "nasze", "naszego", "naszych",
        "natomiast", "natychmiast", "nawet", "nią", "nic", "nich", "nie", "niego", "niej",
        "niemu", "nigdy", "nim", "nimi", "niż", "no", "o", "obok", "od", "około", "on",
        "ona", "one", "oni", "ono", "oraz", "owszem", "pan", "pana", "pani", "po", "pod",
        "podczas", "pomimo", "ponad", "ponieważ", "powinien", "powinna", "powinni", "powinno",
        "poza", "prawie", "przecież", "przed", "przede", "przedtem", "przez", "przy", "roku",
        "również", "sam", "sama", "się", "skąd", "sobie", "sobą", "sposób", "swoje", "są",
        "ta", "tak", "taka", "taki", "takie", "także", "tam", "te", "tego", "tej", "ten",
        "teraz", "też", "totobą", "tobie", "toteż", "trzeba", "tu", "tutaj", "twoi", "twoim",
        "twoja", "twoje", "twym", "twój", "ty", "tych", "tylko", "tym", "u", "w", "wam",
        "wami", "was", "wasz", "wasza", "wasze", "we", "według", "wiele", "wielu", "więc",
        "więcej", "wszyscy", "wszystkich", "wszystkie", "wszystkim", "wszystko", "wtedy",
        "wy", "właśnie", "z", "za", "zapewne", "zawsze", "zeznowu", "znów", "został",
        "żaden", "żadna", "żadne", "żadnych", "że", "żeby"
        ];


    /**
     * @param array $array
     * @return array
     */
    public function normalize($array)
    {
        return array_diff($array, array_merge(self::WORDS_EN, self::WORDS_PL));
    }
}
