using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.EntityFrameworkCore;

namespace RazorMSTutorial.Models;

public class Movie
{
    public int Id { get; set; }
    
    [Required]
    [StringLength(60, MinimumLength = 3)]
    public string? Title { get; set; }
    
    [DataType(DataType.Date)]
    [Display(Name = "Release Date")]
    [Range(typeof(DateTime), "1/1/1966", "1/1/2026")]
    public DateTime ReleaseDate { get; set; }
    
    [RegularExpression(@"^[A-Z]+[a-zA-Z\s]*$")]
    [Required]
    [StringLength(30)]
    public string? Genre { get; set; }
    
    [Range(1, 100)]
    [DataType(DataType.Currency)]
    [Column(TypeName = "decimal(18, 2)")]
    public decimal Price { get; set; }
    
    [RegularExpression(@"^[A-Z]+[a-zA-Z0-9""'\s-]*$")]
    [StringLength(5)]
    [Required]
    public string Rating { get; set; } = String.Empty;
}