using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.PublicTransports
{
    public class IndexModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public IndexModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        public IList<PublicTransport> PublicTransport { get;set; } = default!;

        public async Task OnGetAsync()
        {
            PublicTransport = await _context.PublicTransports.ToListAsync();
        }
    }
}
